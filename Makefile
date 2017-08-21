info:
	@echo "Usage: make test|style|doc|install"

# pass any target to composer
$(MAKECMDGOALS):
	composer $(MAKECMDGOALS)
